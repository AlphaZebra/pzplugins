import { useState } from "@wordpress/element";
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
LicenseInfo.setLicenseKey(
  "94af6ed0a88af0eb477e40d45142c51eTz03MjUyMCxFPTE3MjMzMzc0OTYwMDAsUz1wcm8sTE09c3Vic2NyaXB0aW9uLEtWPTI="
);
import Popover from "@mui/material/Popover";
import Typography from "@mui/material/Typography";

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

const xdiv = document.querySelector(".pz-projectgrid-div");
const attributes = JSON.parse(xdiv.innerText);
const url = attributes.siteURL + "/wp-json/pz/v1/project";

let response = await fetch(url);
let json = await response.text();
let initialRows = JSON.parse(json);

function handleDeleteClick() {
  window.location.href = "./edit-project/";
}

function RenderProjectName({ row, value }) {
  const [anchorEl, setAnchorEl] = useState();
  const open = Boolean(anchorEl);
  const id = open ? "simple-popover" : undefined;

  function handlePopover(event) {
    setAnchorEl(event.currentTarget);
  }
  const handleClose = () => {
    setAnchorEl(null);
  };

  return (
    <div>
      <Typography onClick={handlePopover}>{value}</Typography>
      <Popover
        id={id}
        open={open}
        anchorEl={anchorEl}
        onClose={handleClose}
        anchorOrigin={{
          vertical: "bottom",
          horizontal: "left",
        }}
      >
        <Typography sx={{ p: 2 }}>{row.project_description}</Typography>
      </Popover>
    </div>
  );
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

function getLeadName({ row }) {
  return row.project_lead_name;
}

function RenderLeadName(props) {
  const { value } = props;
  const names = value.split(" ");
  const fname = String(names[0]);
  const lname = String(names[1]);
  //const initial = lname.substring(0, 1);
  let initial = "?";
  if (names.length > 1) {
    initial = lname.charAt(0);
  } else if (names.length == 1) {
    fname.charAt(0);
  } else initial = "?"; // else if no name, the default "?" will serve as the initial
  // const initial = names[1] ? names[1].charAt(0) : names[0].charAt(0); // get last initial, or else first initial
  // const initial = "X";
  return (
    <Chip
      color="primary"
      variant="outlined"
      avatar={<Avatar>{initial}</Avatar>}
      label={value}
    />
  );
}

function RenderEdit({ value }) {
  const url = attributes.editURL + "?prj=" + value;
  return (
    <a href={url}>
      <EditIcon />
    </a>
  );
}
function RenderTaskList({ value, row }) {
  const url = attributes.taskListURL + "?prj=" + value;
  const taskcount = row.tasks ? row.tasks : 0;
  return (
    <a href={url}>
      <Badge badgeContent={taskcount}>
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
    const url = attributes.addURL + "?prj=0";
    window.location.href = url;
  };

  return (
    <GridToolbarContainer>
      <Button color="primary" startIcon={<AddIcon />} onClick={handleClick}>
        Add project
      </Button>
      <GridToolbarColumnsButton />
      <GridToolbarFilterButton />
      <GridToolbarDensitySelector />
    </GridToolbarContainer>
  );
}

const columns = [
  {
    field: "project_name",
    headerName: "Project",
    width: 350,
    renderCell: RenderProjectName,
  },
  {
    field: "project_status",
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
    field: "project_lead",
    headerName: "Project Lead",
    valueGetter: getLeadName,
    renderCell: RenderLeadName,
    width: 180,
  },
  {
    field: "id",
    headerName: " ",
    renderCell: RenderEdit,
    width: 30,
  },
  {
    field: "taskaction",
    headerName: "  ",
    valueGetter: ({ id }) => id,
    renderCell: RenderTaskList,
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

ReactDOM.render(<ProjectGrid />, xdiv);

/**
 *
 * Here's the component donut
 */

function ProjectGrid() {
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
