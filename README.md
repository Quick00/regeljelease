# Pipedrive API integration documentation

## Step 1: Install Dependencies

Run the following command to install all the dependencies for your Laravel project:

```bash
composer install
```

## Step 2: Set up the Environment

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Create a app key:

```bash
php artisan key:generate
```

## Step 3: Set up the variables

Make sure you have ngrok installed and run the following command:

```bash
ngrok http 80
```

Copy the ngrok URL and set it as the `APP_URL` in the `.env` file.

Copy over the Pipedrive API key and set it as the `PIPEDRIVE_API_KEY` in the `.env` file.
You can find this under account -> personal preferences -> API.

## Step 4: Run the application

Make sure to have docker install or have a compatible PHP version installed.

To make it work with docker run the following command:

```bash
docker-compose up -d
```

## Step 5: Create the webhook

To create the webhook, run the following command:

For Docker:
```bash
docker-compose exec -t app php artisan setup:webhook
```

For local PHP:
```bash
php artisan setup:webhook
```

## Step 6: Add deals and change the deal's value

Add a deal in Pipedrive and change the value of the deal to see the webhook in action.
