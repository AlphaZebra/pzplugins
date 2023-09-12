/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

import { useState } from "@wordpress/element"; // WordPress React wrapper
import {
  useBlockProps,
  InspectorControls,
  useSetting,
} from "@wordpress/block-editor";
import {
  PanelBody,
  TextControl,
  RadioControl,
  TreeSelect,
} from "@wordpress/components";
import TextField from "@mui/material/TextField";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
  const { attributes, setAttributes } = props;
  const { backgroundColor } = attributes;
  const [values, setValues] = useState({
    top: "50px",
    left: "10%",
    right: "10%",
    bottom: "50px",
  });

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody>
          <TreeSelect
            label="Choose which table and data field this form field will supply."
            noOptionLabel="No field selected... "
            tree={[
              {
                name: "Person",
                id: "pz_person",
                children: [
                  { name: "First name", id: "firstname" },
                  { name: "Last name", id: "lastname" },
                  { name: "Email", id: "email" },
                ],
              },
              {
                name: "Interaction",
                id: "pz_interaction",
                children: [
                  { name: "First name", id: "firstname" },
                  { name: "Last name", id: "lastname" },
                  { name: "Email", id: "email" },
                ],
              },
            ]}
          />
        </PanelBody>
        <PanelBody title="When Adding/Editing">
          <TextControl
            label="URL for Project Add form"
            value={attributes.addURL}
            onChange={(value) => setAttributes({ addURL: value })}
          />
          <TextControl
            label="URL for Project Edit form"
            value={attributes.editURL}
            onChange={(value) => setAttributes({ editURL: value })}
          />
          <TextControl
            label="URL for Task Lists"
            value={attributes.taskListURL}
            onChange={(value) => setAttributes({ taskListURL: value })}
          />
        </PanelBody>
      </InspectorControls>
      <TextField id="outlined-basic" label="Outlined" variant="outlined" />
    </div>
  );
}
