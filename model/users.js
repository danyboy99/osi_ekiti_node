const mongoose = require("mongoose");
const Schema = mongoose.Schema;

const userSchema = new Schema(
  {
    username: {
      type: String,
      required: true,
      unique: true,
    },
    firstname: {
      type: String,
      required: true,
    },
    lastname: {
      type: String,
      required: true,
    },
    email: {
      type: String,
      required: true,
      unique: true,
    },
    gender: {
      type: String,
      required: true,
    },
    bate_of_birth: {
      type: Date,
      required: true,
    },
    age: {
      type: Number,
    },
    phone_no: {
      type: String,
      required: true,
    },
    password: {
      type: String,
      required: true,
    },
    traditionalAgeGroup: {
      type: Schema.Types.ObjectId,
      ref: "traditionalAgeGroup",
    },
    chief_status: {
      type: Boolean,
      default: false,
    },
  },
  { timestamps: true }
);

const user = mongoose.model("user", userSchema);

module.exports = user;
