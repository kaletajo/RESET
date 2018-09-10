#!/bin/bash
#

counter=0


for value in /var/www/image-classifier/images/2-Psychosis/*
do
    echo "cp $value /var/www/image-classifier/images/2-Psychosis-renamed/psychosis"$counter"_clip.jpg"
    cp $value /var/www/image-classifier/images/2-Psychosis-renamed/psychosis"$counter"_clip.jpg
    counter=$(($counter + 1))
done


