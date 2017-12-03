#!/bin/sh
socat tcp-l:9999,fork exec:./pwn300
