#!/bin/bash

echo "🚀 Starting MediRemind Application..."
echo ""

# Start Laravel Backend in background
echo "📡 Starting Backend (Laravel)..."
cd server
php artisan serve --host=127.0.0.1 --port=8000 &
BACKEND_PID=$!
cd ..

# Wait for backend to start
sleep 3

# Start React Frontend
echo "🎨 Starting Frontend (React)..."
cd client
npm run dev

# Cleanup on exit
trap "kill $BACKEND_PID" EXIT
