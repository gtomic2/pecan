% Generated by roxygen2 (4.0.2): do not edit by hand
\name{invert_prospect_MLE}
\alias{invert_prospect_MLE}
\title{Simple maximum likelihood inversion of PROSPECT4}
\usage{
invert_prospect_MLE(spectra)
}
\arguments{
\item{spectra}{A matrix of reflectance spectra with dimensions 2101 x n,
where n is the number of spectra.}
}
\value{
Vector of maximum likelihood values of PROSPECT parameters
}
\description{
Simple maximum likelihood inversion of PROSPECT4
}
\details{
MLE inversion based on log of sum of squares of error.
}
\examples{
data(testspec)
fit <- invert_prospect_MLE(testspec_ACRU[,1])
plot(400:2100, prospect4(fit),
    type='l',
    xlab="Wavelength (nm)",
    ylab="Reflectance")
lines(400:2100, testspec_ACRU[,1], col=2)
}
\author{
Alexey Shiklomanov
}

