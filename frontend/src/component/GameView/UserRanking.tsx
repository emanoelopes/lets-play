import * as React from "react";

import {Table, TableBody, TableCell, TableHead, TableRow} from "material-ui";
import {Trans} from "react-i18next";
import {Ranking, RankingEntry} from "../../model/models";

export interface UserRankingProps {
	ranking: Ranking;
}

export class UserRanking extends React.PureComponent<UserRankingProps, {}> {
	public render(): JSX.Element {

		const rows: RankingRow[] = this.props.ranking.map((e: RankingEntry, index: number) => {
			return {
				position: index + 1,
				username: e.user.name,
				points: e.points
			};
		});

		for (let i = 1; i < rows.length; i++) {
			if (rows[i].points === rows[i - 1].points) {
				rows[i].position = rows[i - 1].position;
			}
		}

		return (
			<Table>
				<TableHead>
					<TableRow>
						<TableCell><Trans>Position</Trans></TableCell>
						<TableCell><Trans>User</Trans></TableCell>
						<TableCell><Trans>Points</Trans></TableCell>
					</TableRow>
				</TableHead>
				<TableBody>
					{rows.map(this.renderRow)}
				</TableBody>
			</Table>
		);
	}

	private renderRow = (r: RankingRow, index: number) => {
		return (
			<TableRow key={index}>
				<TableCell>{r.position}</TableCell>
				<TableCell>{r.username}</TableCell>
				<TableCell>{r.points}</TableCell>
			</TableRow>
		);
	}
}

interface RankingRow {
	position: number;
	username: string;
	points: number;
}
