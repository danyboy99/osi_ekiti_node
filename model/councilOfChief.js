const mongoose = require("mongoose");
const Schema = mongoose.Schema;

const councilOfChiefSchema = new Schema(
  {
    rank: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    date_of_coronation: {
      type: String,
      required: true,
    },
    role: {
      type: String,
      required: true,
    },
    designation: {
      type: String,
      required: true,
    },
    image: {
      type: String,
      required: true,
    },
    users: {
      type: Schema.Types.ObjectId,
      ref: "User",
    },
  },
  { timestamps: true }
);

const councilOfChief = mongoose.model("councilOfChief", councilOfChiefSchema);
module.exports = councilOfChief;
