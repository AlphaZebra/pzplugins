// import * as React from "react";

import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import AddIcon from "@mui/icons-material/Add";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/DeleteOutlined";
import { LicenseInfo } from "@mui/x-license-pro";

import {
  DataGridPro,
  GridToolbarContainer,
  GridToolbarColumnsButton,
  GridToolbarFilterButton,
  GridToolbarDensitySelector,
} from "@mui/x-data-grid-pro";

LicenseInfo.setLicenseKey(
  "94af6ed0a88af0eb477e40d45142c51eTz03MjUyMCxFPTE3MjMzMzc0OTYwMDAsUz1wcm8sTE09c3Vic2NyaXB0aW9uLEtWPTI="
);

// Retrieve block attributes
const xdiv = document.querySelector(".pz-interactiongrid-div");
const attributes = JSON.parse(xdiv.innerText);

// Get the interactions linked to that person
let interactionURL = "http://" + window.location.hostname;

if (attributes.per == "") {
  interactionURL += "/wp-json/pz/v1/interaction/?per=1";
} else if (attributes.per) {
  interactionURL += "/wp-json/pz/v1/interaction/?per=" + attributes.per;
}

let response = await fetch(interactionURL);
let json = await response.text();
const intInitialRows = JSON.parse(json);

//update project table's count of tasks for this project
// let counturl =
//   "https://peakzebra.com/wp-json/pz/v1/count/?prj=" +
//   attributes.prj +
//   "&count=" +
//   initialRows.length;
// console.log(counturl);
// response = await fetch(counturl);

function handleDeleteClick() {
  window.location.href = "./edit-project/";
}

function RenderEdit({ value }) {
  const url = "/task-info/?t=" + value;
  return (
    <a href={url}>
      <EditIcon />
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
    const url = attributes.addURL + "?int=0&per=" + attributes.per;

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
        Add interaction
      </Button>
      <GridToolbarColumnsButton />
      <GridToolbarFilterButton />
      <GridToolbarDensitySelector />
    </GridToolbarContainer>
  );
}

function IntRenderEdit({ value }) {
  const url = attributes.editURL + "?int=" + value;
  return (
    <a href={url}>
      <EditIcon fontSize="small" />
    </a>
  );
}

const columns = [
  { field: "id", headerName: "Int#" },
  {
    field: "taskaction",
    headerName: "  ",
    valueGetter: ({ id }) => id,
    renderCell: IntRenderEdit,
    width: 30,
  },
  { field: "per_id", headerName: "Person" },
  { field: "summary", headerName: "Interaction", width: 350 },
  {
    field: "details",
    headerName: "Details",
    width: 400,
  },
  { field: "created", headerName: "Created", width: 350 },
];

ReactDOM.render(<InteractionGrid />, xdiv);

/**
 *
 * Here's the component donut
 */

function InteractionGrid() {
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
          rows={intInitialRows}
          columns={columns}
          slots={{
            toolbar: EditToolbar,
          }}
        />
      </Box>
    </div>
  );
}
