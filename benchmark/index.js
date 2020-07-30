'use strict';

module.exports = {
  driverFixtures
};

const faker = require('faker')

function driverFixtures(userContext, events, done) {
  const uuid = faker.random.uuid();
  const phone = faker.helpers.replaceSymbolWithNumber('+346########');

  // add variables to virtual user's context:
  userContext.vars.uuid = uuid;
  userContext.vars.phone = phone;

  // continue with executing the scenario:
  return done();
}
