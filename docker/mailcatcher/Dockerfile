FROM ruby:2.2

ENV MAILCATCHER_VERSION 0.5.12

RUN \
  gem install mailcatcher --no-ri --no-rdoc --version ${MAILCATCHER_VERSION}

EXPOSE 1080
EXPOSE 1025

CMD ["mailcatcher", "-f", "--ip=0.0.0.0"]