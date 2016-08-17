FROM modpreneur/trinity-test:alpine

MAINTAINER Martin Kolek <kolek@modpreneur.com>

# Install app
ADD . /var/app

WORKDIR /var/app

RUN chmod +x entrypoint.sh

ENTRYPOINT ["sh", "entrypoint.sh"]