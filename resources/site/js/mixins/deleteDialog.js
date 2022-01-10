export default {
    methods: {
       async deleteDialog(msg) {
           let deleteCond = false;
            await this.$confirm(msg, 'Удаление', {
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена',
                type: 'warning',
                center: true
            }).then(() => {

                deleteCond = true;

            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Удаление отменено',
                });
                deleteCond = false;
            });
            return deleteCond;
        }
    }
}
