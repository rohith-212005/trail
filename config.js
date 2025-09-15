// Configuration file for the Travel Booking System
// Copy this to .env file and update the values as needed

export const config = {
    MONGO_URI: 'mongodb+srv://dbuser:Rohith%409989@cluster0.davlqmu.mongodb.net/travelBooking',
    PORT: 5000,
    JWT_SECRET: 'your-super-secret-jwt-key-change-this-in-production',
    NODE_ENV: 'development',
    API_BASE_URL: 'http://localhost:5000/api'
};

// Instructions:
// 1. Create a .env file in the root directory
// 2. Copy the following content to .env:
// MONGO_URI=mongodb+srv://dbuser:Rohith%409989@cluster0.davlqmu.mongodb.net/travelBooking
// PORT=5000
// JWT_SECRET=your-super-secret-jwt-key-change-this-in-production
// NODE_ENV=development
