import { TextControl } from "@wordpress/components";

const xdiv = document.querySelector(".pz-target-div");
const atts = JSON.parse(document.querySelector("pre").innerHTML);

ReactDOM.render(<MyComponent p={atts.prompt} />, xdiv);

function MyComponent(props) {
	return (
		<div>
			<TextControl label={props.p} class="test-class" />
		</div>
	);
}
