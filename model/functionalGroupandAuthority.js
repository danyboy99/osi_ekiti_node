const mongoose = require("mongoose");
const Schema = mongoose.Schema;

const functionalGroupandAuthoritySchema = new Schema({
  functionalGroup: {
    type: String,
    required: true,
  },
  member: [
    {
      memeber: String,
      leaderStatus: Boolean,
    },
  ],
});

module.exports = mongoose.model(
  "functionalGroupandAuthority",
  functionalGroupandAuthoritySchema
);
