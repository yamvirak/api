FROM lorisleiva/laravel-docker:7.2
EXPOSE 8000

COPY .  /var/www
RUN rm -f composer.lock
RUN composer update --ignore-platform-reqs
RUN cp .env.example .env
RUN php artisan key:generate

CMD php artisan --host=0.0.0.0 serve