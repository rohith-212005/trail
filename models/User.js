const mongoose = require("mongoose");

const UserSchema = new mongoose.Schema({
    name: String,
    username: { type: String, unique: true },
    password: String,
    phone: String,
    gender: String,
    dob: Date,
    created_at: { type: Date, default: Date.now }
});

module.exports = mongoose.model("User", UserSchema);
