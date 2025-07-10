const mongoose = require("mongoose");
const Schema = mongoose.Schema;

const traditionalAgeGroupSchema = new Schema(
  {
    group_name: {
      type: String,
      required: true,
    },
    group_catigory: {
      type: String,
      required: true,
    },
    age_from: {
      type: Number,
      required: true,
    },
    age_to: {
      type: Number,
      required: true,
    },
    least_age: {
      type: Number,
      required: true,
    },
    most_age: {
      type: Number,
      required: true,
    },
    users: [
      {
        type: Schema.Types.ObjectId,
        ref: "User",
      },
    ],
  },
  { timestamps: true }
);

module.exports = mongoose.model(
  "TraditionalAgeGroup",
  traditionalAgeGroupSchema
);
