FROM modpreneur/trinity-test

MAINTAINER Martin Kolek <kolek@modpreneur.com>

## Install app
#ADD . /var/app

WORKDIR /var/app

#RUN chmod +x entrypoint.sh

ENTRYPOINT ["fish", "entrypoint.sh"]