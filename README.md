To run project locally:

`docker compose up --build`

`docker exec -it books_app /bin/bash`

`php artisan migrate`

`php artisan books:import`

Available endpoints:

``http://127.0.0.1:8000/books?search=Unlocking``

      Response example:
       [
            {
                "title":"Unlocking Android",
                "short_description":"Unlocking Android: A Developer's Guide provides concise, hands-on instruction",
                "long_description":"Unlocking Android: A Developer's Guide provides concise, hands-on instruction for the Android operating system and development tools. This book teaches important architectural",
                "authors":["W. Frank Ableson","Charlie Collins","Robi Sen"],
                "published":"2009-04-01"
            },
            ...
        ]

``http://127.0.0.1:8000/authors``

      Response example:
       [
            {
                "name":"W. Frank Ableson",
                "books_count":3
            },
            ...
        ]

``http://127.0.0.1:8000/authors/{author_id}/books``

      Response example:
        [
            {
                "title":"Unlocking Android",
                "description":null,
                "authors":["W. Frank Ableson","Charlie Collins","Robi Sen"],
                "published":"2009-04-01"
            }
        ]