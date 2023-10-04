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

let cattribute = "";
const xdiv = document.querySelector(".pz-linkgrid-div");
const attributes = JSON.parse(xdiv.innerText);
if (attributes.category != "") {
  cattribute = "/?cat=" + attributes.category; // otherwise, already set to "
}
const url = attributes.siteURL + "/wp-json/pz/v1/link" + cattribute;
console.log(url);

let response = await fetch(url);
let json = await response.text();
let initialRows = JSON.parse(json);
console.log(initialRows);

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

function LinkEditToolbar() {
  if (!attributes.isMenu) return ""; // if the display of top menu on grid is turned off
  return (
    <GridToolbarContainer>
      <GridToolbarColumnsButton />
      <GridToolbarFilterButton />
      <GridToolbarDensitySelector />
    </GridToolbarContainer>
  );
}

function getLink(params) {
  console.log(params);
  return <a href={params.row.link_url}>{params.value} </a>;
}

const columns = [
  {
    field: "link_name",
    headerName: "Link Name",
    headerAlign: "left",
    renderCell: getLink,
    width: 300,
  },
  {
    field: "link_description",
    headerName: "About this Resource",
    headerAlign: "left",
    width: 400,
  },
];

// if (!attributes.isHeader)
//   columns.map((thing) => {
//     thing.headerName = "";
//   });

ReactDOM.render(<LinkGrid />, xdiv);

/**
 *
 * Here's the component donut
 */

function LinkGrid() {
  let myslots = {
    toolbar: LinkEditToolbar,
  };
  if (!attributes.isColumnHeaders) {
    myslots = {
      toolbar: LinkEditToolbar,

      columnHeaders: () => null,
    };
  }

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
        <DataGridPro rows={initialRows} columns={columns} slots={myslots} />
      </Box>
    </div>
  );
}
