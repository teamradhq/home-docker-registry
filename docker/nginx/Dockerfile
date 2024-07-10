FROM nginx:stable-alpine3.19-slim

COPY ./conf.d /etc/nginx/conf.d

# Expose port 80 to the outside world
EXPOSE 80

# Start Nginx when the container launches
CMD ["nginx", "-g", "daemon off;"]
