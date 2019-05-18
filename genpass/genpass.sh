#! /bin/bash

printf $1 | md5 | cut -c 1-10 | base64 | cut -c 1-11 | tr -d '\n'
