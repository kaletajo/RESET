'''
# multiple cascades: https://github.com/Itseez/opencv/tree/master/data/haarcascades
# https://pythonprogramming.net/haar-cascade-face-eye-detection-python-opencv-tutorial/

'''

import numpy as np
import cv2
import os, sys


#https://github.com/Itseez/opencv/blob/master/data/haarcascades/haarcascade_frontalface_default.xml
face_cascade = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')


filename = sys.argv[1]


print("filename = ", filename)

(output_filename, fext) = os.path.splitext(filename)
output_filename = output_filename + "_clip"
output_filename = output_filename + fext
print(output_filename)


img = cv2.imread(filename)


height, width, channels = img.shape
#print("height ", height, " width ", width, " channels ", channels)

gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
faces = face_cascade.detectMultiScale(gray, 1.3, 5)

for (x,y,w,h) in faces:
    perc = 0.3
    xdiff = x * perc
    ydiff = y * perc
    x = int(x - xdiff)
    y = int(y - ydiff)
    w = int(w + (2 * xdiff))
    h = int(h*1.3 + (4 * ydiff)) 
    #print("x ", x, " y ", y, " w ", w, " h ", h)
    #print("x+w ", x+w, " y+h ", y+h)
    cv2.rectangle(img,(x,y),(x+w,y+h),(255,0,0),2)
    roi_gray = gray[y:y+h, x:x+w]
    roi_color = img[y:y+h, x:x+w]
    break
    

#cv2.imshow('roi_color', roi_color)
cv2.imwrite(output_filename, roi_color)






