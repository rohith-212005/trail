const mongoose = require("mongoose");

const loginSchema = new mongoose.Schema({
    userId: mongoose.Schema.Types.ObjectId, // link to the user
    username: String,
    loginTime: { type: Date, default: Date.now }
});

module.exports = mongoose.model("Login", loginSchema);
