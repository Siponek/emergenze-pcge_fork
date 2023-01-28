// This file will export the dashboard api calls for fetching and managinging the dashboard data

export async function retr_message(root_div, message_id) {
  const request_options = {
    method: "GET",
    redirect: "follow",
  };
  // Retrieve the list of messages from url with GET method
  // and then put it ien the div in table format
  if (message_id == "") {
    return console.log("message_id is empty");
  }
  let message_dict = null;
  await fetch(`${root_div}_retrive_message_list`, request_options)
    .then((asyn_response) => asyn_response.json())
    .then((async_result) => {
      const message_list = async_result.result;
      return Object.entries(message_list).forEach(([key, value]) => {
        // message_list.forEach((element) => {
        if (key == message_id) {
          message_dict = {};
          message_dict.message = value;
        }
      });
    })
    .catch((error) => console.log("error", error));
  if (message_dict != null) {
    return message_dict;
  }
  console.log(`element with id ${message_id} was not found`);
  return null;
}

export function format_date(date) {
  const date_str = date.split(" ")[0];
  const time_str = date.split(" ")[1];
  const date_arr = date_str.split("-");
  const time_arr = time_str.split(":");
  const year = date_arr[2];
  const month = date_arr[1];
  const day = date_arr[0];
  const hour = time_arr[0];
  const minute = time_arr[1];
  const second = time_arr[2];
  return `${year}/${month}/${day} ${hour}:${minute}:${second}`;
}

export function convert_to_date(string_date) {
  const date = new Date(string_date);
  const final_date =
    date.getUTCFullYear() +
    "-" +
    (date.getUTCMonth() + 1) +
    "-" +
    date.getUTCDate() +
    " " +
    date.getUTCHours() +
    ":" +
    date.getUTCMinutes() +
    ":" +
    date.getUTCSeconds();
  return final_date;
}
