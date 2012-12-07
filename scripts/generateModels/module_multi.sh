#!/bin/bash

for y in `ls multi/*.php`;
do sed s/xxx/$1/g $y > temp; 
sed s/XXX/$2/g temp > temp2; 
echo $y | sed s/Xxx/$2/g | xargs -i mv temp2 {}
mv multi/$2* ./
rm temp*
done
