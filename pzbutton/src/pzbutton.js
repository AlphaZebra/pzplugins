import { useState } from "@wordpress/element";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import Select from "@mui/material/Select";
import { LicenseInfo } from "@mui/x-license-pro";
LicenseInfo.setLicenseKey(
  "94af6ed0a88af0eb477e40d45142c51eTz03MjUyMCxFPTE3MjMzMzc0OTYwMDAsUz1wcm8sTE09c3Vic2NyaXB0aW9uLEtWPTI="
);

let fattributes = [];
let dattributes = [];

const fdiv = document.querySelectorAll(".pz-textfield-div");
if (fdiv) {
  console.log(fdiv);
  for (let i = 0; i < fdiv.length; i++) {
    fattributes = JSON.parse(fdiv[i].innerText);
    ReactDOM.render(<PZTextField prompt={fattributes.prompt} />, fdiv[i]);
  }
}

const ddiv = document.querySelectorAll(".pz-dropdown-div");
if (ddiv) {
  for (let i = 0; i < ddiv.length; i++) {
    dattributes = JSON.parse(ddiv[i].innerText);
    ReactDOM.render(<PZDropDown prompt={dattributes.prompt} />, ddiv[i]);
  }
}

const xdiv = document.querySelector(".pz-button-div");
if (xdiv) {
  const attributes = JSON.parse(xdiv.innerText);
}

/**
 *
 * Here's the component donut
 */

function PZTextField(props) {
  return (
    <div>
      <TextField id="outlined-basic" label={props.prompt} variant="outlined" />
    </div>
  );
}

function PZDropDown(props) {
  return (
    <div>
      <InputLabel id="demo-simple-select-label">{props.prompt}</InputLabel>
      <Select
        labelId="demo-simple-select-label"
        id="demo-simple-select"
        label={props.prompt}
        value={20}
      >
        <MenuItem value={10}>Ten</MenuItem>
        <MenuItem value={20}>Twenty</MenuItem>
        <MenuItem value={30}>Thirty</MenuItem>
      </Select>
    </div>
  );
}

ReactDOM.render(<PZButton />, xdiv);

/**
 *
 * Here's the component donut
 */

function PZButton() {
  return (
    <div>
      <Button id="pzbutton" variant="contained" size="large">
        Submit
      </Button>
    </div>
  );
}
