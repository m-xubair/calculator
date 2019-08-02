

## Calculator

Clone repository and follow the the following steps to setup application.

Note: You must have docker install on your system.

- After cloning switch into `calculator` directory `cd calculator`.
- This application will run on port `8080`. Make sure no application is running on port `8080`.
- `docker-compose up -d` This command will take few minutes to install the containers and dependencies.
- `./setup.sh` This command will install laravel, node dependencies and setup databases for application and testing.
- After successful setup go to your browser and test the app using `http://0.0.0.0:8080`.
- To run backend tests in your terminal type `docker-compose exec app ./vendor/bin/phpunit`
- To run frontend test in your terminal type `docker-compose exec app npm run test`
- Make sure you are in `calculator` directory while running tests.
