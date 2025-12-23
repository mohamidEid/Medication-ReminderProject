#!/bin/bash

# ألوان
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo "========================================="
echo "  فحص متطلبات Docker"
echo "========================================="
echo ""

# فحص Docker
echo -n "فحص Docker... "
if command -v docker &> /dev/null; then
    docker_version=$(docker --version)
    echo -e "${GREEN}✓ موجود${NC}"
    echo "  $docker_version"
else
    echo -e "${RED}✗ غير موجود${NC}"
    echo -e "${RED}يرجى تثبيت Docker أولاً: https://docs.docker.com/get-docker/${NC}"
    exit 1
fi
echo ""

# فحص Docker Compose
echo -n "فحص Docker Compose... "
if command -v docker-compose &> /dev/null; then
    compose_version=$(docker-compose --version)
    echo -e "${GREEN}✓ موجود${NC}"
    echo "  $compose_version"
else
    echo -e "${RED}✗ غير موجود${NC}"
    echo -e "${RED}يرجى تثبيت Docker Compose أولاً${NC}"
    exit 1
fi
echo ""

# فحص حالة Docker daemon
echo -n "فحص حالة Docker daemon... "
if docker ps &> /dev/null; then
    echo -e "${GREEN}✓ يعمل${NC}"
else
    echo -e "${RED}✗ لا يعمل${NC}"
    echo -e "${YELLOW}قم بتشغيل Docker daemon أولاً${NC}"
    exit 1
fi
echo ""

# فحص المنافذ المطلوبة
echo "فحص المنافذ المطلوبة..."
for port in 80 3306 6379 8080; do
    echo -n "  المنفذ $port... "
    if lsof -Pi :$port -sTCP:LISTEN -t >/dev/null 2>&1; then
        echo -e "${YELLOW}⚠ مستخدم${NC}"
        echo -e "    ${YELLOW}قد تحتاج إلى إيقاف الخدمة المستخدمة لهذا المنفذ${NC}"
    else
        echo -e "${GREEN}✓ متاح${NC}"
    fi
done
echo ""

# فحص وجود ملفات Docker
echo "فحص ملفات Docker..."
files=(
    "Dockerfile"
    "docker-compose.yml"
    "docker-setup.sh"
    "Makefile"
    "docker/nginx/default.conf"
    "docker/php/local.ini"
    "docker/mysql/my.cnf"
)

all_exist=true
for file in "${files[@]}"; do
    echo -n "  $file... "
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC}"
    else
        echo -e "${RED}✗${NC}"
        all_exist=false
    fi
done
echo ""

# النتيجة النهائية
echo "========================================="
if [ "$all_exist" = true ]; then
    echo -e "${GREEN}✓ جميع الفحوصات نجحت!${NC}"
    echo ""
    echo -e "${GREEN}يمكنك الآن تشغيل المشروع:${NC}"
    echo -e "  ${YELLOW}./docker-setup.sh${NC}"
    echo -e "أو:"
    echo -e "  ${YELLOW}make install${NC}"
else
    echo -e "${RED}✗ بعض الملفات مفقودة${NC}"
    echo "يرجى التأكد من وجود جميع ملفات Docker"
fi
echo "========================================="
