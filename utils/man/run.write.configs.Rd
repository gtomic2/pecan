% Generated by roxygen2 (4.1.0): do not edit by hand
% Please edit documentation in R/run.write.configs.R
\name{run.write.configs}
\alias{run.write.configs}
\title{Run model specific write configuration functions}
\usage{
run.write.configs(settings, write = TRUE)
}
\arguments{
\item{write}{should the runs be written to the database}

\item{model}{the ecosystem model to generate the configuration files for}
}
\description{
Main driver function to call the ecosystem model specific (e.g. ED, SiPNET)
run and configuration file scripts
}
\author{
David LeBauer, Shawn Serbin
}

