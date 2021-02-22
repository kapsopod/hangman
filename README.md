# hangman
Procedural PHP hangman game that reads countries from a file

## Assumptions
The environment you will try to run the program by following the steps below is linux and your web server (if you don't have docker set up) has PHP set up.

## TO RUN
- Download the project from github as a zip file.
- Once downloaded unzip.
- You should end up with a "hangman-main" directory.
- All the contents of "hangman-main", including folder "hangman-main" need permissions change. So on linux I run the following command: "chmod -R 777 hangman-main"
- Once the above steps have been taken, there are 2 options:

1. If you have docker set up, go into "hangman-main" and run the following command: "docker-compose up". On the terminal it should show which IP docker's web server can be accessed at. E.g. on my machine it is usually 172.21.0.2. Enter this IP on your browser and you should see the program running.
2. If you have a web server running, copy the "hangman-main" directory into the web server, and access it from your web browser.
