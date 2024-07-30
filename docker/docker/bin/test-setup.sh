#!/usr/bin/env sh

# Pull some images so the registry is not empty, then remove them from the local image.
docker pull hello-world:latest
docker pull alpine:latest
docker image rm hello-world:latest alpine:latest