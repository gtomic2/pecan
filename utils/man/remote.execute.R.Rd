% Generated by roxygen2 (4.1.0): do not edit by hand
% Please edit documentation in R/remote.R
\name{remote.execute.R}
\alias{remote.execute.R}
\title{Execute command remotely}
\usage{
remote.execute.R(script, host = "localhost", user = NA, verbose = FALSE,
  R = "R")
}
\arguments{
\item{script}{the script to be invoked, as a list of commands.}

\item{host}{host to execute command on}

\item{user}{the username to use for remote login}

\item{verbose}{should the output be printed to the console}

\item{args}{a character vector of arguments to command.}
}
\value{
the captured output of the command (both stdout and stderr)
}
\description{
Execute command remotely
}
\details{
Executes the given command on the remote host using ssh. If the user is set
the system will login as the given user. If the host given is the local
machine it will execute the command locally without ssh.
}
\examples{
remote.execute.R("list.files()", host="localhost", verbose=FALSE)
}
\author{
Rob Kooper
}

