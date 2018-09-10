#!/bin/bash
#
# Apply OpenCV face-detection based on Haar cascades.
# Output is a clipped copy of any image files
#

for value in /var/www/image-classifier/data/train/*/*
do
    python clip_image.py $value
done


for value in /var/www/image-classifier/data/test/*/*
do
    python clip_image.py $value
done

