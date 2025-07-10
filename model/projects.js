const mongoose = require("mongoose");
const Schema = mongoose.Schema;

const projectSchema = new Schema(
  {
    title: {
      type: String,
      required: true,
    },
    project_disc: {
      type: String,
      required: true,
    },
    cost: {
      type: String,
      required: true,
    },
    contractor: {
      type: String,
      required: true,
    },
    status: {
      type: String,
      required: true,
    },
    start_date: {
      type: String,
      required: true,
    },
    end_date: {
      type: String,
    },
  },
  { timestamps: true }
);
