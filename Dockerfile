FROM ubuntu:latest

ENV DEBIAN_FRONTEND noninteractive

# Speed up APT
RUN echo "force-unsafe-io" > /etc/dpkg/dpkg.cfg.d/02apt-speedup && echo "Acquire::http {No-Cache=True;};" > /etc/apt/apt.conf.d/no-cache

RUN apt update \
    && apt install -y mysql-client dos2unix dumb-init unzip \
    && apt install -y apache2 php libapache2-mod-php \
    && apt install -y \
    php-mysql \
    php-bz2 \
    php-gd \
    php-mbstring \
    php-dom \
    php-zip \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh && dos2unix /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
