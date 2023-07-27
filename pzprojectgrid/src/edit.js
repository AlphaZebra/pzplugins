/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useState } from "@wordpress/element";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __experimentalBoxControl as BoxControl } from "@wordpress/components";
import { PanelBody, TextControl, CheckboxControl } from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

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
  const [values, setValues] = useState({
    top: "50px",
    left: "10%",
    right: "10%",
    bottom: "50px",
  });

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title="Spacing">
          <BoxControl
            label="Margin"
            values={values}
            onChange={(nextValues) => setValues(nextValues)}
          />
          <CheckboxControl
            label="Edit Current Person?"
            checked={attributes.isEdit}
            onChange={(value) => setAttributes({ isEdit: value })}
          />
        </PanelBody>

        <PanelBody title="When Adding">
          <TextControl
            label="URL for Project Add form"
            value={attributes.addURL}
            onChange={(value) => setAttributes({ addURL: value })}
          />
        </PanelBody>
      </InspectorControls>
      <TextControl
        label="Enter some data"
        value={attributes.myheader}
        onChange={(newValue) => setAttributes({ myheader: newValue })}
      />
    </div>
  );
}
