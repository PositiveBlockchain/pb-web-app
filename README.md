# Positive Blockchain Database

Positiveblockchain.io (PB) is an open-source database. The database includes blockchain projects, startups, products with social impact. This repository is an open-source project. The goal is to develop a web application and a RESTful web service for others to consume data for system integration .
 
 ## Goals
 1. Provide a REST API for the data which has been collected by volunteering contributors.
 2. Build a dashboard to display and show key metrics about the projects.
 3. Allow external developers use the data and integrate them into their system.
 4. One goal is to replace the curation process (WordPress) with an own web application.
 
 ## Dev System
 You can see the work in progress on https://pb.chainist.de. The site is a development server, thus probably in constant change. Things might break or not available. A production server will be available as soon it is ready.
 
 ## Technical Architecture
 We are using Laravel, the rapid development framework for PHP. The first version will use the Corcel dependency to access the Wordpress database. The solution filters the necessary data from the Wordpress database and returns only required data for the REST API. The architecture will evolve over time.

- Vue Leaflet and Leaflet https://vue2-leaflet.netlify.app/
- OpenStreetMap tiles https://www.openstreetmap.org/copyright
- TailwindCSS https://tailwindcss.com/
- Laravel https://laravel.com/
- Corcel https://github.com/corcel/corcel
 
 ## API Documentation
 Plan is to generate a swagger documentation for according to the Open API specification. This way you will be able to generate PB client APIs for your programming language. What's this? See https://github.com/swagger-api/swagger-codegen for more details.
  
  ## Contributors
  Nhan Vu,\
  https://github.com/jobnomade \
  https://nhanvu.de/
 
 More contributors to come…
  
