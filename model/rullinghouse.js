const mongoose = require("mongoose");
const Schema = mongoose.Schema;
const rullingHouseSchema = new Schema(
  {
    name: {
      type: String,
      required: true,
    },
    head: {
      type: String,
      required: true,
    },
    image: {
      type: String,
      required: true,
    },
  },
  { timestamps: true }
);
const RullingHouse = mongoose.model("RullingHouse", rullingHouseSchema);
module.exports = RullingHouse;
