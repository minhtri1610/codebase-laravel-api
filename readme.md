# Laravel + PostgreSQL + Next.js Setup

A Docker-based boilerplate for Laravel (backend) and Next.js (frontend) with PostgreSQL and Redis.

## Getting Started

Run this command to initialize environment variables, start containers, install dependencies, and run migrations:

```bash
make setup
```

Once running, the applications are available at:
- **Frontend**: [http://localhost:3000](http://localhost:3000)
- **Backend (API)**: [http://localhost:8000](http://localhost:8000)

## Quick Commands

Configure shortcuts directly in the [Makefile](file:///Users/IntelTri/WorkPlace/WWW/01Projects/PHP/set-up/laravel-postgres-nextjs-setup/Makefile):

- `make setup` — Initialize env, start containers, install dependencies, run migrations.
- `make up` / `make down` — Start / Stop containers.
- `make restart` / `make build` — Restart / Rebuild containers.
- `make logs` / `make ps` — View container logs / statuses.
- `make migrate` / `make migrate-fresh` — Run / Refresh database migrations.
- `make backend-shell` / `make frontend-shell` — Access backend / frontend CLI.