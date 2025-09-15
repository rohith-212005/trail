require("dotenv").config();

const express = require("express");
const mongoose = require("mongoose");
const path = require("path");
const User = require("./models/User");
const Login = require("./models/Login");


const app = express();

// ✅ Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname));

// ✅ MongoDB Atlas Connection
mongoose.connect(process.env.MONGO_URI)
    .then(() => console.log("✅ MongoDB Atlas connected"))
    .catch(err => console.error("❌ Connection error:", err));

// ====== Register API ======
app.post("/register", async (req, res) => {
    try {
        console.log("📩 Data from form:", req.body);

        const { name, username, password, confirm_password, phone, gender, dob } = req.body;

        if (password !== confirm_password) {
            return res.status(400).send("❌ Passwords do not match");
        }

        const existing = await User.findOne({ username });
        if (existing) {
            return res.status(400).send("❌ User already exists");
        }

        const newUser = new User({ name, username, password, phone, gender, dob });
        const savedUser = await newUser.save();

        console.log("✅ Saved to DB:", savedUser);

        res.redirect("homepage.html");
    } catch (err) {
        console.error("❌ Error:", err);
        res.status(500).send("❌ Error: " + err.message);
    }
});


// ====== Login API ======
// ====== Login API ======
app.post("/login", async (req, res) => {
    try {
        const { username, password } = req.body;

        const user = await User.findOne({ username });

        if (!user) {
            return res.redirect("/?error=" + encodeURIComponent("❌ You are not registered. Please register first."));
        }

        if (user.password !== password) {
            return res.redirect("/?error=" + encodeURIComponent("❌ Incorrect password or Username"));
        }

        // ✅ Save login record to "logins" collection
        await Login.create({
            userId: user._id,
            username: user.username
        });

        // ✅ Redirect to homepage
        res.redirect("homepage.html");

    } catch (err) {
        res.redirect("/?error=" + encodeURIComponent("❌ Error: " + err.message));
    }
});

// ====== Default Route ======
app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "index.html"));
});

// ✅ Start server
const port = process.env.PORT || 5000;
app.listen(port, () => {
    console.log(`🚀 Server running at http://localhost:${port}`);
});
