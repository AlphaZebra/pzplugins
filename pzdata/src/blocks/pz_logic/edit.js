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
	TextControl,
	CheckboxControl,
	SelectControl,
	TextareaControl,
} from "@wordpress/components";
//import { useState } from "@wordpress/element";

// const MySelectControl = () => {
const field = "fname";
// };

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
	return (
		<div {...useBlockProps()}>
			<InspectorControls>
				<PanelBody title="Access">
					<CheckboxControl
						label="Restrict to logged-in users?"
						checked={attributes.isLogged}
						onChange={(value) => setAttributes({ isLogged: value })}
					/>
					<CheckboxControl
						label="Restrict to admin access?"
						checked={attributes.isAdmin}
						onChange={(value) => setAttributes({ isAdmin: value })}
					/>
				</PanelBody>
				<PanelBody title="Redirect">
					<TextControl
						label="URL for redirect if access denied"
						value={attributes.editURL}
						onChange={(value) => setAttributes({ editURL: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div class="pz-page-access">
				<hr />
				<h4>If something somethings something</h4>

				<SelectControl
					label="Field"
					value={attributes.field}
					options={[
						{ label: "First Name", value: "fname" },
						{ label: "Last Name", value: "lname" },
						{ label: "Company", value: "company" },
					]}
					onChange={(value) => setAttributes({ field: value })}
				/>
				<SelectControl
					label="comparison"
					value={attributes.comparison}
					options={[
						{ label: "equals", value: "=" },
						{ label: "isn't", value: "!=" },
						{ label: "is greater than", value: ">" },
					]}
					onChange={(value) => setAttributes({ comparison: value })}
				/>
				<TextControl
					label="Target value"
					value={attributes.targetValue}
					onChange={(value) => setAttributes({ targetValue: value })}
				/>
				<TextareaControl
					help="Enter what should be displayed"
					label="Display"
					onChange={(value) => setAttributes({ displayText: value })}
					value={attributes.displayText}
				/>
				<SelectControl
					label="Set"
					value={attributes.setField}
					options={[
						{ label: "First Name", value: "fname" },
						{ label: "Last Name", value: "lname" },
						{ label: "Company", value: "company" },
					]}
					onChange={(value) => setAttributes({ setField: value })}
				/>
				<TextareaControl
					help="Enter the new value for the field"
					label="Set to:"
					onChange={(value) => setAttributes({ setValue: value })}
					value={attributes.setValue}
				/>
			</div>
		</div>
	);
}
