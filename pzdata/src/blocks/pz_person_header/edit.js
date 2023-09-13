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
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";

import {
	PanelBody,
	RadioControl,
	TextControl,
	CheckboxControl,
} from "@wordpress/components";
import { useState } from "@wordpress/element";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const [option, setOption] = useState("fname");
	const imageURL =
		window.location.origin +
		"/wp-content/plugins/pzprojectform/includes/assets/edit-side-image.png";
	if (!attributes.field) {
		setAttributes({ field: option });
	}

	return (
		<div {...useBlockProps()}>
			<InspectorControls>
				<PanelBody title="Edit Existing?">
					<CheckboxControl
						label="Edit Current Person?"
						checked={attributes.isEdit}
						onChange={(value) => setAttributes({ isEdit: value })}
					/>
				</PanelBody>
				<PanelBody title="If person pre-exists?">
					<CheckboxControl
						label="Error if not new person?"
						checked={attributes.mustBeNew}
						onChange={(value) => setAttributes({ mustBeNew: value })}
					/>
				</PanelBody>

				<PanelBody title="Redirect">
					<TextControl
						label="URL for redirect after add"
						value={attributes.redirectURL}
						onChange={(value) => setAttributes({ redirectURL: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<table>
				<tr>
					<td>
						<img src={imageURL}></img>
					</td>
					<td>
						<h4>PZ Person Form</h4>
					</td>
				</tr>
			</table>{" "}
		</div>
	);
}