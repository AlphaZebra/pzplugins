// import * as React from "react";
import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import AddIcon from "@mui/icons-material/Add";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/DeleteOutlined";
import SaveIcon from "@mui/icons-material/Save";
import CancelIcon from "@mui/icons-material/Close";
import FormatListBulletedIcon from "@mui/icons-material/FormatListBulleted";
import Badge from "@mui/material/Badge";
import Chip from "@mui/material/Chip";
import Avatar from "@mui/material/Avatar";
import { LicenseInfo } from "@mui/x-license-pro";

import {
  GridRowModes,
  DataGridPro,
  GridToolbar,
  GridToolbarContainer,
  GridToolbarColumnsButton,
  GridToolbarFilterButton,
  GridToolbarExport,
  GridToolbarDensitySelector,
} from "@mui/x-data-grid-pro";

// window.onload = function () {
//   if (window.jQuery) {
//     // jQuery is loaded
//     alert("Yeah!");
//   } else {
//     // jQuery is not loaded
//     alert("Doesn't Work");
//   }
// };
// // Get the specific project record
// const url = "http://suchthings.local/wp-json/pz/v1/project";
// let response = await fetch(url);
// let json = await response.text();
// let projectRows = JSON.parse(json);

LicenseInfo.setLicenseKey(
  "94af6ed0a88af0eb477e40d45142c51eTz03MjUyMCxFPTE3MjMzMzc0OTYwMDAsUz1wcm8sTE09c3Vic2NyaXB0aW9uLEtWPTI="
);

// Retrieve block attributes
const xdiv = document.querySelector(".pz-taskgrid-div");
const attributes = JSON.parse(xdiv.innerText);
// console.log(attributes);

// Get the tasks linked to that project
let taskurl = "";
if (attributes.prj == "") {
  taskurl =
    "http://suchthings.local/wp-json/pz/v1/task/?prj=99999" + attributes.prj;
} else if (attributes.prj) {
  taskurl = "http://suchthings.local/wp-json/pz/v1/task/?prj=" + attributes.prj;
} else if (attributes.appName) {
  taskurl =
    "http://suchthings.local/wp-json/pz/v1/task/?app=" + attributes.appName;
}

let response = await fetch(taskurl);
let json = await response.text();
let initialRows = JSON.parse(json);

//update project table's count of tasks for this project
let counturl =
  "http://suchthings.local/wp-json/pz/v1/count/?prj=" +
  attributes.prj +
  "&count=" +
  initialRows.length;
console.log(counturl);
response = await fetch(counturl);

function handleDeleteClick() {
  window.location.href = "./edit-project/";
}

function RenderStatus(props) {
  const { value } = props;
  let displayStatus = "";
  switch (value) {
    case "pending":
      displayStatus = "Pending";
      return <Chip label={displayStatus} color="primary" />;
      break;
    case "inprocess":
      displayStatus = "In Process";
      return <Chip label={displayStatus} color="secondary" />;
      break;
    case "inreview":
      displayStatus = "In Review";
      return <Chip label={displayStatus} color="info" />;
      break;
    case "done":
      displayStatus = "Done";
      return <Chip label={displayStatus} color="success" />;
      break;
    default:
      displayStatus = "None";
      return <Chip label={displayStatus} color="warning" />;
  }
}

// function RenderLeadName(props) {
//   const { value } = props;
//   const names = value.split(" ");
//   console.log(names);
//   const fname = String(names[0]);
//   const lname = String(names[1]);
//   //const initial = lname.substring(0, 1);
//   console.log(lname);
//   let initial = "?";
//   if (names.length > 1) {
//     initial = lname.charAt(0);
//   } else if (names.length == 1) {
//     fname.charAt(0);
//   } else initial = "?"; // else if no name, the default "?" will serve as the initial
//   // const initial = names[1] ? names[1].charAt(0) : names[0].charAt(0); // get last initial, or else first initial
//   // const initial = "X";
//   return (
//     <Chip
//       color="primary"
//       variant="outlined"
//       avatar={<Avatar>{initial}</Avatar>}
//       label={value}
//     />
//   );
// }

function RenderEdit({ value }) {
  const url = "/task-info/?t=" + value;
  return (
    <a href={url}>
      <EditIcon />
    </a>
  );
}

function RenderTaskList({ value }) {
  const url = attributes.taskListURL + "?t=" + value;
  return (
    <a href={url}>
      <Badge badgeContent={4}>
        <FormatListBulletedIcon />
      </Badge>
    </a>
  );
}
function RenderDelete({ value }) {
  const url = window.location.href;
  return (
    <div>
      <form action="/wp-admin/admin-post.php" method="POST">
        <input type="hidden" name="action" value="do-project-delete" required />
        <input type="hidden" name="id" value={value} required />
        <input type="hidden" name="postDeleteURL" value={url} required />
        <button type="submit" name="submit" class="clearbutton">
          <DeleteIcon />
        </button>
      </form>
    </div>
  );
}

function EditToolbar() {
  const handleClick = () => {
    const url = attributes.addURL + "?prj=" + attributes.prj;

    //   const id = randomId();
    //   setRows((oldRows) => [...oldRows, { id, name: '', age: '', isNew: true }]);
    //   setRowModesModel((oldModel) => ({
    //     ...oldModel,
    //     [id]: { mode: GridRowModes.Edit, fieldToFocus: 'name' },
    //   }));
    window.location.href = url;
  };

  return (
    <GridToolbarContainer>
      <Button color="primary" startIcon={<AddIcon />} onClick={handleClick}>
        Add task
      </Button>
      <GridToolbarColumnsButton />
      <GridToolbarFilterButton />
      <GridToolbarDensitySelector />
    </GridToolbarContainer>
  );
}

const columns = [
  { field: "task_name", headerName: "Tasks", width: 350 },
  {
    field: "task_status",
    type: "singleSelect",
    valueOptions: ["Pending", "In Process", "In Review", "Done"],
    headerName: "Status",
    headerAlign: "left",
    renderCell: RenderStatus,
  },
  {
    field: "kickoff_date",
    headerName: "Kickoff date",
    type: "dateTime",
    valueGetter: ({ value }) => value && new Date(value),
    width: 100,
  },
  {
    field: "due_date",
    headerName: "Due date",
    type: "dateTime",
    valueGetter: ({ value }) => value && new Date(value),
    width: 100,
  },
  {
    field: "task_assignee",
    headerName: "Assigned to",
    width: 180,
  },
  {
    field: "id",
    headerName: " ",
    renderCell: RenderEdit,
    width: 30,
  },
  {
    field: "delete",
    headerName: "  ",
    valueGetter: ({ id }) => id,
    renderCell: RenderDelete,
    onClick: handleDeleteClick,
    width: 30,
  },
];

ReactDOM.render(<TaskGrid />, xdiv);

/**
 *
 * Here's the component donut
 */

function TaskGrid() {
  return (
    <div height="400" width="100%">
      <Box
        sx={{
          height: 300,
          width: "100%",
          "& .actions": {
            color: "text.secondary",
          },
          "& .textPrimary": {
            color: "text.primary",
          },
        }}
      >
        <DataGridPro
          rows={initialRows}
          columns={columns}
          slots={{
            toolbar: EditToolbar,
          }}
        />
      </Box>
    </div>
  );
}
