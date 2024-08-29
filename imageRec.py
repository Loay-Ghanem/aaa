import sys
import json
import google.generativeai as genai # Ensure you have the required library installed

# API Key for the GenAI service


def main():
    API_KEY = "AIzaSyCE_TfmldGkMCHvjMHqCNPgS14o6GTjeSo"
    try:

        #img = sys.argv[1]


        # Configure the GenAI API with the provided key
        genai.configure(api_key=API_KEY)

        def upload_to_gemini(path, mime_type='image/png'):
            """Uploads the given file to Gemini.

            See https://ai.google.dev/gemini-api/docs/prompting_with_media
            """
            file = genai.upload_file(path, mime_type=mime_type)
            return file

        # Define the generation configuration for the model
        generation_config = {
            "temperature": 0,
            "top_p": 0.95,
            "top_k": 64,
            "max_output_tokens": 8192,
            "response_mime_type": "application/json",
        }

        # Create the Generative Model
        model = genai.GenerativeModel(
            model_name="gemini-1.5-flash",
            generation_config=generation_config,
            system_instruction="Try to analyze plate numbers only or return  not found",
        )

        # Upload files to Gemini (update the file paths as needed)

        files = [
            upload_to_gemini(r"C:\\xampp\\htdocs\\aaa\\public\\storage\\temp\\1.png", mime_type="image/png"),
        ]

        # Start a chat session with the model
        chat_session = model.start_chat(
            history=[
                # {
                #     "role": "user",
                #     "parts": [
                #         files[0],
                #     ],
                # },
                # {
                #     "role": "model",
                #     "parts": [
                #         "```json\n{\"plate\": \"invalid\"}\n\n```",
                #     ],
                # },
            ]
        )

        # Send a message to analyze the image to recognize the plate
        response = chat_session.send_message("Analyze image to recognize plate")

        # Print the response from the model
        print(response.text)

    except json.JSONDecodeError as e:
        print(f"Error decoding JSON: {e}", file=sys.stderr)
    except KeyError as e:
        print(f"Key error: {e}", file=sys.stderr)
    except Exception as e:
        print(f"An error occurred: {e}", file=sys.stderr)

if __name__ == "__main__":
    main()
