# Positive Blockchain Database

Positiveblockchain.io (PB) is an open-source database. The database includes blockchain projects, startups, products with social impact. This repository is an open-source project. The goal is to develop a web application.
 
 ## Goals
 1. Provide a REST API for the data which has been collected by volunteering contributors.
 2. Build a dashboard to display and show key metrics about the project data.
 3. Allow external developers use the data and integrate them into their system.
 
 ## Dev System
 You can see the work in progress on https://pb.chainist.de. The site is a development server, thus probably in constant change. Things might break or not available. A production server will be available as soon it is ready.
 
 ## Technical Architecture
 We are using Laravel (https://laravel.com/), the rapid development framework for PHP. The first version will use the Corcel depenency (https://github.com/corcel/corcel) to access the Wordpress database. The solution will filter the necessary data and returns only required data for the REST API.
  
