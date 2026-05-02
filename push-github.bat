@echo off
chcp 65001 >nul
cd /d "C:\laragon\kedaipinky\KedaiPinky\Kedai"

echo.
echo ========================================
echo Git Push to GitHub
echo ========================================
echo.

echo [1/7] Checking git status...
git status
echo.

echo [2/7] Checking remotes...
git remote -v
echo.

echo [3/7] Adding remote origin...
git remote add origin https://github.com/rizqi239/kedai.git 2>nul
if errorlevel 1 (
    echo Remote already exists, updating URL...
    git remote set-url origin https://github.com/rizqi239/kedai.git
)
echo.

echo [4/7] Staging all files...
git add .
echo Files staged successfully
echo.

echo [5/7] Creating commit...
git commit -m "Initial commit: KedaiPinky project"
echo.

echo [6/7] Renaming branch to main...
git branch -M main
echo.

echo [7/7] Pushing to GitHub...
git push -u origin main

echo.
echo ========================================
echo Push completed!
echo ========================================
echo.
echo Verify at: https://github.com/rizqi239/kedai
echo.
pause
