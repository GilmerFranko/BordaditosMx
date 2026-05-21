
git diff --name-only HEAD~5..HEAD | tr '\n' '\0' | xargs -0 git archive -o cambios_kingsbeet.tar.gz HEAD --
