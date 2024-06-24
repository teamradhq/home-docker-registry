# Home Docker Registry

This project provides the necessary tools to serve a Docker registry on a home network. 

The documentation assumes that the registry will be deployed on the local network at `docker.registry.local`. Substitute this for your local ip address or hostname.

## Deploying a registry

Copy `.example.env` to `.env`:

```bash
cp -n .example.env .env
```

Edit `.env` to set the desired values.

Serve the registry with:

```bash
docker-compose up -d
```

## Configuring Hosts

Edit `/etc/docker/daemon.json` to use the local registry as a mirror:

```json
{
  "registry-mirrors": ["http://docker.registry.local:5000"]
}
```

