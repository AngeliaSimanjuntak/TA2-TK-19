import cv2,os
from tkinter import *
import tkinter.messagebox
import requests
import json
import time
import face_recognition

Server = "192.168.99.103"

URL_wajah = "http://"+Server+"/visitor/api/getFotoJson.php"
URL_deteksi = "http://"+Server+"/visitor/api/deteksiJson.php"
URL_download = "http://"+Server+"/visitor/uploads/wajah/"

idDevice = "2"
secretKey = "visitor2022"

delay_capture = 30

root = Tk()
root.title("Scan Dulu, Yuk!!")
root.geometry("480x600")
main = Label(root, text="Sistem Pendataan Jumlah Pengunjung", font=("arial", 14, "bold"), fg="steelblue").pack()
main2 = Label(root, text="Menggunakan 2 Indikator", font=("arial", 14, "bold"), fg="steelblue").pack()

labelID = Label(root, text="Input ID (Manual)", font=("arial", 12, "bold"), fg="darkgreen").place(x=10,y=155)
nikID = StringVar()
nikID_box = Entry(root, bd=2, textvariable=nikID, width=40, bg="lightgreen", fg="red").place(x=180,y=161)
nama = "";
dataNIK = "";

def get_ID():       #capture foto
    flag = False
    captureQRcode = False
    
    try:
        str(nikID.get())
        if str(nikID.get()) != "":
            dataNIK = str(nikID.get())
            flag = True
        else:
            print("Capture QR Code")
            captureQRcode = True
    except Exception as e:
        print(e)
        tkinter.messagebox.showinfo("Error", e)

    if captureQRcode:    #recognize qrcode
        cam = cv2.VideoCapture(0)
        qrCodeDetector = cv2.QRCodeDetector()
        qrDetected = 0
        
        while True:
            try:
                ret, imRead =cam.read()
                decodedText, points, _ = qrCodeDetector.detectAndDecode(imRead)
                 
                if points is not None:
                    print("QR Code Detected = ")
                    points = points[0]
                    for i in range(len(points)):
                        pt1 = [int(val) for val in points[i]]
                        pt2 = [int(val) for val in points[(i + 1) % 4]]
                        cv2.line(imRead, tuple(pt1), tuple(pt2), color=(0, 255, 0), thickness=3)
                 
                    print(decodedText)
                    dataNIK = decodedText
                    qrDetected = qrDetected + 1

                    if qrDetected > 5:
                        flag = True
                        cam.release()
                        cv2.destroyAllWindows()
                        break
                else:
                    print("QR Code Not Detected")
                    qrDetected = 0

                cv2.imshow("QR Code Detection", imRead)
                if cv2.waitKey(100) & 0xFF==ord('q'):
                    cam.release()
                    cv2.destroyAllWindows()
                    break
            except Exception as e:
                print(e)
                

    if flag:
        try:
            print("Connecting to Web")
            send_data = requests.get(URL_wajah, params={"key": secretKey, "uuid":dataNIK}, timeout=5)
            print(send_data.text)
            send_data_json = send_data.json()
            print(json.dumps(send_data_json, indent=4, sort_keys=True))

            if send_data_json["status"] == "success":
                nama = send_data_json["nama"]
                wajah_url_download = URL_download+send_data_json["wajah"]
                print(wajah_url_download)
                img_data = requests.get(wajah_url_download).content
                with open('wajah.jpg', 'wb') as handler:
                    handler.write(img_data)
            else:
                flag = False
                tkinter.messagebox.showinfo("Error", "Data ID Tidak Ditemukan")
    
        except Exception as e:
            print(e)
            flag = False

    if flag:
        try:
            print("Starting Capture...")
            print("ID = "+dataNIK)
            NID = dataNIK

            print("Starting Capture...")

            cam = cv2.VideoCapture(0)
            font = cv2.FONT_HERSHEY_SIMPLEX
            cascadePath = "include/face.xml"
            faceCascade = cv2.CascadeClassifier(cascadePath);
            i=0
            detectFace = False
            while True:
                ret, imRead =cam.read()
                #im = cv2.flip(imRead, flipCode=1)
                im = imRead
                gray = cv2.cvtColor(im,cv2.COLOR_BGR2GRAY)
                faces = faceCascade.detectMultiScale(
                    gray,
                    scaleFactor = 1.2,
                    minNeighbors = 5,
                    minSize = (30, 30),
                    flags = cv2.CASCADE_SCALE_IMAGE
                )
                for(x,y,w,h) in faces:
                    detectFace = True
                    cv2.rectangle(im,(x,y),(x+w,y+h),(225,0,0),2)
                    cv2.putText(im,nama, (x,y+h),font,0.5,(0,255,0), 2)
                    
                cv2.imshow('frame capture',im)
                if detectFace:
                    i=i+1

                if i > 50:
                    cv2.imwrite("newface.jpg", im)
                    cv2.waitKey(5000)
                    break
                
                if cv2.waitKey(10) & 0xFF==ord('q'):
                    cam.release()
                    cv2.destroyAllWindows()
                    break
                
            cam.release()
            cv2.destroyAllWindows()
            
            known_image = face_recognition.load_image_file("wajah.jpg")
            unknown_image = face_recognition.load_image_file("newface.jpg")
            
            
            nik_encoding = face_recognition.face_encodings(known_image)[0]
            
            unknown_encoding = face_recognition.face_encodings(unknown_image)[0]
            
            results = face_recognition.compare_faces([nik_encoding], unknown_encoding, tolerance=0.4)  #lower better
            print(results)
            print(results[0])

            if results[0]:
                send_deteksi = requests.get(URL_deteksi, params={"key": secretKey, "iddev":idDevice, "uuid":NID}, timeout=5)
                print(send_deteksi.text)
                dataJson = send_deteksi.json()
                tkinter.messagebox.showinfo("Success", dataJson["ket"])
            else:
                print("Data Wajah Tidak Cocok")
                tkinter.messagebox.showinfo("Error", "Data Wajah Tidak Cocok")
        except Exception as e:
            print(e)
            tkinter.messagebox.showinfo("Error", "Data Wajah Tidak Cocok")
            cam.release()
            cv2.destroyAllWindows()

    


btn = Button(root, text="Sign IN", width=20, height=3, bg="lightblue", fg="darkblue",
             font=("arial", 13, "italic"), command=get_ID).place(x=140,y=240)


root.mainloop()


