const Admin = require("../model/admin");
const CouncilOfChief = require("../model/councilOfChief");
const User = require("../model/users");
const Events = require("../model/events");
const FunctionalGroupAndAuthority = require("../model/functionalGroupandAuthority");
const Notification = require("../model/notification");
const Project = require("../model/projects");
const Quarters = require("../model/quarters");
const RullingHouse = require("../model/rullinghouse");
const TraditionalAgeGroup = require("../model/traditionalAgeGroup");
// service to create new admin account
const createAdmin = async (username, password, email) => {
  try {
    const admin = await Admin.create({
      username,
      password,
      email,
    });
    return {
      status: true,
      message: "Admin created successfully",
      data: admin,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};
// service to create new functionalGroupandAuthority
const createFunctionalGroup = async (functionalGroup, member) => {
  try {
    const newFunctionalGroup = await FunctionalGroupAndAuthority.create({
      functionalGroup,
      member,
    });
    return {
      status: true,
      message: "FunctionalGroupAndAuthority created successfully",
      data: newFunctionalGroup,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new council of chiefs record
const createCouncilOfChief = async (
  rank,
  title,
  name,
  date_of_coronation,
  role,
  designation,
  image
) => {
  try {
    const newCouncilOfChief = await CouncilOfChief.create({
      rank,
      title,
      name,
      date_of_coronation,
      role,
      designation,
      image,
    });
    return {
      status: true,
      message: "CouncilOfChief created successfully",
      data: newCouncilOfChief,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new events record
const createEvents = async (title, event_disc, date, venue, event_catigory) => {
  try {
    const newEvents = await Events.create({
      title,
      event_disc,
      date,
      venue,
      event_catigory,
    });
    return {
      status: true,
      message: "Events created successfully",
      data: newEvents,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new notifacation record
const createNotification = async (from, title, message, type) => {
  try {
    const newNotification = await Notification.create({
      from,
      title,
      message,
      type,
    });
    return {
      status: true,
      message: "Notification created successfully",
      data: newNotification,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new project record
const createProjects = async (
  title,
  project_disc,
  cost,
  contractor,
  status,
  start_date,
  end_date
) => {
  try {
    const newProjects = await Project.create({
      title,
      project_disc,
      cost,
      contractor,
      status,
      start_date,
      end_date,
    });
    return {
      status: true,
      message: "Project created successfully",
      data: newProjects,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new quarters record
const createQuarters = async (quarter, members) => {
  try {
    const newQuarters = await Quarters.create({
      quarter,
      members,
    });
    return {
      status: true,
      message: "Quarters created successfully",
      data: newQuarters,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new rulling house record
const createRullingHouse = async (name, head, image) => {
  try {
    const newRullingHouse = await RullingHouse.create({
      name,
      head,
      image,
    });
    return {
      status: true,
      message: "RullingHouse created successfully",
      data: newRullingHouse,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// service to create new traditionalAgeGroup record
const createTraditionalAgeGroup = async (
  group_name,
  group_catigory,
  age_from,
  age_to,
  least_age,
  most_age
) => {
  try {
    const newTraditionalAgeGroup = await TraditionalAgeGroup.create({
      group_name,
      group_catigory,
      age_from,
      age_to,
      least_age,
      most_age,
    });
    return {
      status: true,
      message: "TraditionalAgeGroup created successfully",
      data: newTraditionalAgeGroup,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

// get all admin
const getAllAdmin = async () => {
  try {
    const allAdmin = await Admin.find();
    return {
      status: true,
      message: "All Admin",
      data: allAdmin,
    };
  } catch (err) {
    console.log("from service", err);
    return {
      status: false,
      messsage: err.message,
    };
  }
};

module.exports = {
  createAdmin,
  createFunctionalGroup,
  createCouncilOfChief,
  createEvents,
  createNotification,
  createProjects,
  createQuarters,
  createRullingHouse,
  createTraditionalAgeGroup,
  getAllAdmin,
};
