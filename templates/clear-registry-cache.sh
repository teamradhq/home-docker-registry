#!/bin/bash

REGISTRY_URL="http://docker.registry.local:5000"

# Delete a tag from the repo.
# $1: repository name
# $2: tag name
delete_tag() {
    local repo=$1
    local tag=$2

    digest=$(curl -s -H "Accept: application/vnd.docker.distribution.manifest.v2+json" \
        "$REGISTRY_URL/v2/$repo/manifests/$tag" \
        | jq -r '.config.digest')

    curl -s -X DELETE "$REGISTRY_URL/v2/$repo/manifests/sha256:$digest"
}

# List all repositories in the registry.
list_repositories() {
    curl -s "$REGISTRY_URL/v2/_catalog" | jq -r '.repositories[]'
}

# List all tags in the registry.
#
# $1: repository name
# Output: list of tags
list_tags() {
    local repo=$1
    curl -s "$REGISTRY_URL/v2/$repo/tags/list" | jq -r '.tags[]'
}

for repo in $(list_repositories); do
    for tag in $(list_tags $repo); do
        if [ "$tag" == "latest" ]; then
            echo "Invalidating $repo:$tag"
            delete_tag $repo $tag

            docker pull $REGISTRY_URL/$repo:latest
        fi
    done
done
