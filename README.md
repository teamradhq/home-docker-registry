# Home Docker Registry


This project provides the necessary tools to serve a Docker registry on a home network. 

> **Note:**
> 
> The documentation assumes that the registry will be deployed on the local network at `docker.registry.local`.
> 
> Substitute this for your local ip address or hostname.

## Introduction

This project provides a single service to serve a Docker registry on a home network. The registry is served over HTTP and is not secured and is not intended to be accessed over WAN connection. 

**The intended purposes for this service are:**

1. Keep local copies of images to reduce bandwidth and speed up deployments.
2. Store images that you want to keep private, without using a third party service like Dockerhub, ECR, etc.
3. Serve images to other hosts on your network.

## Starting the registry

Copy `.example.env` to `.env`:

```bash
cp -n .example.env .env
```

Edit `.env` to set the desired values.

Serve the registry with:

```bash
docker-compose up -d
```

You should now be able to pull an image from Dockerhub via the registry:

```bash
docker pull docker.registry.local:5000/alpine:latest
```

## Configuring a Systemd Service

A service template is provided that you can install on a server. This will define a service named `docker-registry` that will start automatically when the system boots:

```bash
./bin/install-docker-registry-service.sh
```

Start, stop, reload and service status can be managed with:

```bash
sudo systemctl start docker-registry
sudo systemctl stop docker-registry
sudo systemctl reload docker-registry
sudo systemctl status docker-registry
```

## Configuring Hosts

Once you have configured a local registry, you can configure other Docker hosts on your network to use it as a mirror. 

Edit `/etc/docker/daemon.json` to use the local registry as a mirror:

```json
{
  "registry-mirrors": ["http://docker.registry.local:5000"]
}
```

> **Note for Docker Desktop Mac Users**
> 
> You should configure this via the Dashboard app. 
> 
> Go to `Preferences` -> `Docker Engine` and add the `registry-mirrors` to the daemon configuration, and then restart Docker Desktop.

You can verify this is working by monitoring the registry service:

```bash
# On registry host
cd /path/to/this/project
docker compose logs -f registry
```

Then attempt to pull an image on the client host you've configured:

```bash
# On client host
docker pull alpine:latest
```

You should see some log entries appear on the registry host.

## Roadmap

I've reviewed Portus and Harbor. Portus is no longer maintained, and Harbor seems overly complicated. If this project were intended for a large audience, it might make sense to implement these. However, for a small home network, I think this project is sufficient.

However, there are some features that could be useful:

- [ ] Define a cleanup command to run periodically and remove old / unused images.
- [ ] Define a command that backs up registry data to a remote location.
- [ ] Provide a simple gui to list available images:
  - [ ] Mirrored from Dockerhub
  - [ ] Uploaded to the local registry

