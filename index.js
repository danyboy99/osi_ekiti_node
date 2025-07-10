const express = require("express");
const mongoose = require("mongoose");
const path = require("path");
const port = process.env.PORT || 2025;
const dotenv = require("dotenv");
const app = express();

dotenv.config();
// connect to database
let DB_URL = process.env.local_DB_url; // Changed to match your .env file
mongoose
  .connect(DB_URL, {
    useNewUrlParser: true,
    useUnifiedTopology: true,
  })
  .then(() => console.log("Connected to MongoDB..."))
  .catch((err) => console.error("Could not connect to MongoDB...", err));

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "public")));
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));
app.use("/css", express.static(path.join(__dirname, "public/css")));
app.use("/js", express.static(path.join(__dirname, "public/js")));

app.get("/", (req, res) => {
  res.json("welcome to osi ekiti index page");
});

app.listen(port, () => {
  console.log(`Server started on port ${port}`);
});
