### Overview
Access your RingCentral account's call log database using the call-log API.

### RingCentral Connect Platform
RingCentral Connect Platform is a rich RESTful API platform with more than 70 APIs for business communication includes advanced voice calls, chat messaging, SMS/MMS and Fax.

### RingCentral Developer Portal
To setup a free developer account, click [https://developer/ringcentral.com](here)

### Clone the project
```
git clone https://github.com/ringcentral-tutorials/calllog-visualization-php-demo

cd calllog-visualization-php-demo

curl -sS https://getcomposer.org/installer | php

php composer.phar require ringcentral/ringcentral-php

php composer.phar require vlucas/phpdotenv

cp dotenv .env

php -S localhost:5000
```
Remember to add your app client ID and client secret as well as account login credentials to the .env file.

Open your Web browser and enter localhost:5000

## RingCentral PHP SDK
The SDK is available at https://github.com/ringcentral/php
