const mongoose = require("mongoose");
const Schema = mongoose.Schema;

const quartersSchema = new Schema({
  quarter: {
    type: String,
    required: true,
  },
  members: [
    {
      member: String,
      leaderStatus: Boolean,
    },
  ],
});

module.exports = mongoose.model("quarters", quartersSchema);
