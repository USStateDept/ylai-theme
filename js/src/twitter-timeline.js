/**
  * JS generated Twitter User Timelines for YLAI
  *
  * @param {object} settings - The settings object
  * @param {object} settings.dataSource - The data source definition for a timeline
  * @param {string} settings.dataSource.sourceType - Default: profile
  * @param {string} settings.dataSource.screenName - Any valid Twitter screen name
  * @param {string} settings.dataSource.userId - Any valid Twitter user ID
  * @prarm {string} settings.elementId - The element's id
  * @param {string} [settings.options.chrome] - Remove a display component of a timeline with space-separated tokens
  * @param {int}    [settings.options.tweetLimit] - Display an expanded timeline of between 1 and 20 Tweets
  * @param {string} [settings.options.ariaPolite] - Set an assertive ARIA politeness value for widget components and updates
  * @param {string} [settings.options.related] - Suggest additional Twitter usernames related to the widget as comma-separated values
  * @param {string} [settings.options.lang] - A supported Twitter language code
  * @param {string} [settings.options.theme] - When set to dark, displays Tweet with light text over a dark background
  * @param {string} [settings.options.linkColor] - Adjust the color of Tweet links with a hexadecimal color value
  * @param {string} [settings.options.borderColor] - Set the color of widget component borders, including the border between Tweets, with a hexadecimal color value
  * @param {int}    [settings.options.width] - Set the maximum width of the widget between 180 and 520 pixels
  * @param {int}    [settings.options.height] - Set the height of a displayed widget, overriding the value stored with the widget ID. Must be greater than 200 pixels
  * @param {string} [settings.options.screenName] - Display Tweets from a Twitter user specified by username
  * @param {int}    [settings.options.userId] - Display Tweets from a Twitter user specified by ID
  * @param {string} [settings.options.listOwnerScreenName] - Display a Twitter list belonging to a Twitter user specified by @username. Must be paired with a specific list provided by list-slug or list-id
  * @param {string} [settings.options.listOwnerId] - Display a Twitter list belonging to a Twitter user specified by @username. Must be paired with a specific list provided by list-slug or list-id
  * @param {string} [settings.options.listSlug] - Display a Twitter list using a short identifier selected by its curator. Must be paired with a list curator provided by list-owner-screen-name or list-owner-id
  * @param {string} [settings.options.listId] - Display a Twitter list using a unique identifier assigned by Twitter. Must be paired with a list curator provided by list-owner-screen-name or list-owner-id
  * @param {int}    [settings.options.customTimlineId] - Display a collection of Tweets specified by a collection identifier
  *
  * @see https://dev.twitter.com/web/embedded-timelines/parameters
  */

(function() {
  'use strict';

  var homepage = {
    dataSource: {
      sourceType: 'profile',
      screenName: 'YLAINetwork'
    },
    elementId: 'twitter-timeline',
    options: {
      chrome: 'nofooter',
      height: 800
    }
  };

  function createTimeline(settings) {
    var element = document.getElementById(settings.elementId);

    twttr.ready(function(twttr) {
      twttr.widgets.createTimeline(settings.dataSource, element, settings.options)
        .catch(function(error) { console.error(error.message) });
    });
  }

  function isPage(page) {
    var bool = false;
    var body = document.querySelector('body');
    var classes = body.className.split(' ');
    var index = classes.indexOf(page);

    if (index !== -1) {
      bool = true;
    }

    return bool;
  }

  if (isPage('home') === true) {
    createTimeline(homepage);
  }
})();
