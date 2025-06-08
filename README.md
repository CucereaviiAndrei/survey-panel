## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up --wait` to set up and start the project
4. Run `make reset` to create database, run migrations and load fixtures (install make package if needed `sudo apt install make`)
5. Open `https://localhost` in your favorite web browser and enjoy ;)
